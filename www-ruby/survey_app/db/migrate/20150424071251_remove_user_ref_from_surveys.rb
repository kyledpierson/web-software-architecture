class RemoveUserRefFromSurveys < ActiveRecord::Migration
  def change
    remove_reference :surveys, :user, index: true, foreign_key: true
  end
end
