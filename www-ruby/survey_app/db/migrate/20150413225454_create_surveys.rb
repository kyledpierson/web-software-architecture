class CreateSurveys < ActiveRecord::Migration
  def change
    create_table :surveys do |t|
      t.string :title
      t.text :question
      t.float :yes
      t.float :no
      t.references :user, index: true, foreign_key: true

      t.timestamps null: false
    end
    add_index :surveys, [:user_id, :created_at]
  end
end
